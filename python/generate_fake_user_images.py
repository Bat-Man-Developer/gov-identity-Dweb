import os
import numpy as np
import face_recognition
import dlib
import cv2
import random
from PIL import Image
from keras.models import load_model
# Set the number of images to generate
num_images = 10
# Set the output directory
output_dir = "C:/Xampp/htdocs/gov-identity-Dweb/datasets/stored_user_images"
# Create the output directory if it doesn't exist
if not os.path.exists(output_dir):
 os.makedirs(output_dir)
# Load the pre-trained face recognition model
face_detector = dlib.get_frontal_face_detector()
# Load the pre-trained StyleGAN model
stylegan_model = load_model("stylegan.h5")
# Loop through the number of images to generate
for i in range(num_images):
 # Generate a random face embedding
 face_embedding = np.random.normal(size=(1, 512))
 # Generate a random image from the face embedding using StyleGAN
 generated_image = stylegan_model.predict(face_embedding)
 # Convert the generated image to a PIL image
 pil_image = Image.fromarray(np.uint8(generated_image[0] * 255))
 # Generate a random file extension
 file_extension = random.choice(["png", "jpg", "jpeg"])
 # Generate a random file name
 file_name = f"face_{i}.{file_extension}"
 # Save the image to the output directory
 pil_image.save(os.path.join(output_dir, file_name))