import random
import csv
from datetime import datetime, timedelta

# Define the fraudulent and non-fraudulent status
fraudulent_status = ["Fraudulent", "Pending"]
non_fraudulent_status = ["Approved", "Pending"]

# Define the header row
header = ["application_id", "user_id", "first_name", "last_name", "date_of_birth", "place_of_birth", "gender", "nationality", "address", "father_name", "mother_name", "marital_status", "occupation", "document_type", "photo_path", "signature_path", "id_number", "status", "updated_at", "created_at"]

# Function to generate a random date within a range
def random_date(start, end):
    return start + timedelta(
        seconds=random.randint(0, int((end - start).total_seconds()))
    )

# Lists for more diverse names and places
first_names = ["John", "Jane", "David", "Sarah", "Michael", "Emily", "William", "Elizabeth", "James", "Maria", "Robert", "Jennifer", "Richard", "Patricia", "Charles", "Linda", "Joseph", "Barbara", "Thomas", "Margaret"]
last_names = ["Smith", "Johnson", "Brown", "Davis", "Miller", "Wilson", "Moore", "Taylor", "Anderson", "Thomas", "Jackson", "White", "Harris", "Martin", "Thompson", "Garcia", "Martinez", "Robinson", "Clark", "Rodriguez"]
cities = ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia", "San Antonio", "San Diego", "Dallas", "San Jose", "Austin", "Jacksonville", "Fort Worth", "Columbus", "San Francisco", "Charlotte", "Indianapolis", "Seattle", "Denver", "Washington"]
occupations = ["Engineer", "Doctor", "Lawyer", "Teacher", "Student", "Unemployed", "Retired", "Farmer", "Artist", "Other", "Nurse", "Accountant", "Salesperson", "Manager", "Chef", "Electrician", "Plumber", "Scientist", "Researcher", "Entrepreneur"]

# Open a file for writing
with open('C:/Xampp/htdocs/gov-identity-Dweb/admin/datasets/id_applications.csv', 'w', newline='') as file:
    writer = csv.writer(file)

    # Write the header row
    writer.writerow(header)

    # Generate 2000 ID applications
    for i in range(1, 2001):
        application_id = i
        user_id = i
        first_name = random.choice(first_names)
        last_name = random.choice(last_names)
        date_of_birth = random_date(datetime(1950, 1, 1), datetime(2000, 12, 31)).strftime("%Y-%m-%d")
        place_of_birth = random.choice(cities)
        gender = random.choice(["male", "female"])
        nationality = "United States"
        address = f"{random.randint(100, 9999)} {random.choice(['Main', 'Oak', 'Pine', 'Maple', 'Cedar'])} {random.choice(['Street', 'Avenue', 'Road', 'Boulevard', 'Lane'])}, {random.choice(cities)}"
        father_name = f"{random.choice(first_names)} {last_name}"
        mother_name = f"{random.choice(first_names)} {random.choice(last_names)}"
        marital_status = random.choice(["single", "married", "divorced", "widowed"])
        occupation = random.choice(occupations)
        document_type = "nationalID"
        photo_path = f"../uploads/user_{user_id}/user_photo/ID_photo_{user_id}.png"
        signature_path = f"../uploads/user_{user_id}/user_signature/signature_{user_id}.png"
        id_number = random.randint(0000000000000, 9999999999999)
        
        if i <= 1000:
            status = random.choice(fraudulent_status)
        else:
            status = random.choice(non_fraudulent_status)
        
        created_at = random_date(datetime(2023, 1, 1), datetime(2024, 9, 30)).strftime("%Y-%m-%d %H:%M:%S")
        updated_at = random_date(datetime.strptime(created_at, "%Y-%m-%d %H:%M:%S"), datetime(2024, 9, 30)).strftime("%Y-%m-%d %H:%M:%S")

        row = [application_id, user_id, first_name, last_name, date_of_birth, place_of_birth, gender, nationality, address, father_name, mother_name, marital_status, occupation, document_type, photo_path, signature_path, id_number, status, updated_at, created_at]
        writer.writerow(row)