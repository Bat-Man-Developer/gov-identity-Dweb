import os
import numpy as np
from tensorflow.keras.applications.resnet50 import ResNet50, preprocess_input
from tensorflow.keras.preprocessing import image
from tensorflow.keras.models import Model
from sklearn.neighbors import NearestNeighbors

class ImageMatcher:
    def __init__(self, train_directory):
        self.train_directory = train_directory
        self.model = None
        self.nn = None
        self.image_names = None
        self._train_model()

    def _load_and_preprocess_image(self, img_path):
        img = image.load_img(img_path, target_size=(224, 224))
        x = image.img_to_array(img)
        x = np.expand_dims(x, axis=0)
        x = preprocess_input(x)
        return x

    def _extract_features(self, img_path):
        img = self._load_and_preprocess_image(img_path)
        features = self.model.predict(img)
        return features.flatten()

    def _train_model(self):
        base_model = ResNet50(weights='imagenet', include_top=False, pooling='avg')
        self.model = Model(inputs=base_model.input, outputs=base_model.output)
        
        features = []
        image_names = []
        for img_name in os.listdir(self.train_directory):
            img_path = os.path.join(self.train_directory, img_name)
            feat = self._extract_features(img_path)
            features.append(feat)
            image_names.append(img_name)
        
        features = np.array(features)
        self.nn = NearestNeighbors(n_neighbors=1, metric='cosine')
        self.nn.fit(features)
        
        self.image_names = image_names

    def find_matching_image(self, query_directory):
        for img_name in os.listdir(query_directory):
            query_path = os.path.join(query_directory, img_name)
            query_feat = self._extract_features(query_path)
            distances, indices = self.nn.kneighbors([query_feat])
            
            if distances[0][0] < 0.5:  # Threshold for similarity
                matched_image = self.image_names[indices[0][0]]
                return matched_image.split('.')[0]  # Return matched image name without extension
        
        return "Image not found"

def main():
    train_directory = "C:/Xampp/htdocs/gov-identity-Dweb/datasets/stored_users_images"
    query_directory = "C:/Xampp/htdocs/gov-identity-Dweb/datasets/temp_users_image"

    matcher = ImageMatcher(train_directory)
    result = matcher.find_matching_image(query_directory)
    print(result)

if __name__ == "__main__":
    main()