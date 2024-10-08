import numpy as np
import matplotlib.pyplot as plt
from skimage.transform import resize
from keras.models import Sequential
from keras.layers import Conv2D, MaxPooling2D, Dense, Flatten, Input
from keras.optimizers import Adam
from keras import backend as K
import os
from sklearn.model_selection import train_test_split
from keras.utils import to_categorical

class FaceRecognitionCNN:
    def __init__(self, im_shape=(128, 128, 3), batch_size=32):
        self.im_shape = im_shape
        self.batch_size = batch_size
        self.model = None
        self.history = None

    def load_data(self, directory):
        images = []
        labels = []
        class_names = sorted(os.listdir(directory))
        
        for class_id, class_name in enumerate(class_names):
            class_dir = os.path.join(directory, class_name)
            for image_name in os.listdir(class_dir):
                image_path = os.path.join(class_dir, image_name)
                img = plt.imread(image_path)
                img = self.preprocess_image(img)
                images.append(img)
                labels.append(class_id)
        
        self.x = np.array(images)
        self.y = np.array(labels)
        self.num_classes = len(class_names)
        
        self.x_train, self.x_test, self.y_train, self.y_test = train_test_split(
            self.x, self.y, test_size=0.2, random_state=42)
        
        self.y_train = to_categorical(self.y_train, self.num_classes)
        self.y_test = to_categorical(self.y_test, self.num_classes)

    def preprocess_image(self, img):
        img_resized = resize(img, self.im_shape[:2], anti_aliasing=True)
        if img_resized.ndim == 2:
            img_resized = np.stack((img_resized,) * 3, axis=-1)
        return img_resized

    def build_model(self):
        K.clear_session()
        self.model = Sequential([
            Input(shape=self.im_shape),
            Conv2D(filters=32, kernel_size=3, activation='relu'),
            MaxPooling2D(pool_size=2),
            Conv2D(filters=64, kernel_size=3, activation='relu'),
            MaxPooling2D(pool_size=2),
            Flatten(),
            Dense(64, activation='relu'),
            Dense(self.num_classes, activation='softmax')
        ])

        self.model.compile(
            loss='categorical_crossentropy',
            optimizer=Adam(learning_rate=0.001),
            metrics=['accuracy']
        )

    def train_model(self, epochs=50):
        self.history = self.model.fit(
            self.x_train, self.y_train,
            batch_size=self.batch_size,
            epochs=epochs,
            verbose=1,
            validation_split=0.2
        )

    def evaluate_model(self):
        score = self.model.evaluate(self.x_test, self.y_test, verbose=0)
        print('Test loss: {:.4f}'.format(score[0]))
        print('Test accuracy: {:.4f}'.format(score[1]))

    def predict_single_image(self, image_path):
        img = plt.imread(image_path)
        img = self.preprocess_image(img)
        img = np.expand_dims(img, axis=0)  # Add batch dimension

        prediction = self.model.predict(img)
        predicted_class = np.argmax(prediction)
        confidence = np.max(prediction)

        return predicted_class, confidence

    def compare_with_local_images(self, single_image_path, local_directory):
        single_image_class, single_image_confidence = self.predict_single_image(single_image_path)

        matches = []

        for class_name in os.listdir(local_directory):
            class_dir = os.path.join(local_directory, class_name)
            if os.path.isdir(class_dir):
                for image_file in os.listdir(class_dir):
                    image_path = os.path.join(class_dir, image_file)
                    predicted_class, confidence = self.predict_single_image(image_path)

                    if predicted_class == single_image_class:
                        matches.append((image_file, confidence))

        return single_image_class, single_image_confidence, matches

def main():
    # Initialize the CNN
    cnn = FaceRecognitionCNN()

    # Load and preprocess the data from local directory
    local_directory = 'C:/Xampp/htdocs/gov-identity-Dweb/datasets/stored_user_images/'  # Replace with your local directory path
    cnn.load_data(local_directory)

    # Build the model
    cnn.build_model()

    # Display model summary
    cnn.model.summary()

    # Train the model
    cnn.train_model(epochs=50)  # Adjust epochs as needed

    # Evaluate the model
    cnn.evaluate_model()

    # Compare single image with local directory images
    single_image_path = 'C:/Xampp/htdocs/gov-identity-Dweb/datasets/temp_user_image/login_user_photo.png'

    predicted_class, single_image_confidence, matches = cnn.compare_with_local_images(single_image_path, local_directory)

    print(f"The single image matches class {predicted_class} with confidence {single_image_confidence:.2f}")
    print("Matches found in local directory:")
    for match in matches:
        print(f"Image: {match[0]}, Confidence: {match[1]:.2f}")

if __name__ == "__main__":
    main()