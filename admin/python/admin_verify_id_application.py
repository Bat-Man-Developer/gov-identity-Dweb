import pandas as pd
import numpy as np

# Load the datasets
id_applications = pd.read_csv('C:/Xampp/htdocs/gov-identity-Dweb/admin/datasets/id_applications.csv')
verify_id_application = pd.read_csv('C:/Xampp/htdocs/gov-identity-Dweb/admin/datasets/verify_id_application.csv')

def generate_sa_id_number(date_of_birth, gender, citizen_status):
    year = date_of_birth.year % 100
    month = date_of_birth.month
    day = date_of_birth.day
    gender_digit = np.random.randint(0, 5) if gender == 'Female' else np.random.randint(5, 10)
    sequence = np.random.randint(0, 1000)
    citizen_digit = 0 if citizen_status == 'Citizen' else 1
    id_number = f"{year:02d}{month:02d}{day:02d}{gender_digit}{sequence:03d}{citizen_digit}8"
    digits = [int(d) for d in id_number]
    odd_sum = sum(digits[::2])
    even_sum = sum([int(d)*2 // 10 + int(d)*2 % 10 for d in id_number[1::2]])
    checksum = (10 - (odd_sum + even_sum) % 10) % 10
    return id_number + str(checksum)

def find_unused_id(existing_ids, date_of_birth, gender, citizen_status):
    while True:
        new_id = generate_sa_id_number(date_of_birth, gender, citizen_status)
        if new_id not in existing_ids:
            return new_id

# Get existing ID numbers
if 'id_number' in id_applications.columns:
    existing_ids = set(id_applications['id_number'].astype(str))
else:
    existing_ids = set()

# Convert 'id_number' column to string type
if 'id_number' in verify_id_application.columns:
    verify_id_application['id_number'] = verify_id_application['id_number'].astype(str)
else:
    verify_id_application['id_number'] = ''

# Process verify_id_application
for index, row in verify_id_application.iterrows():
    date_of_birth = pd.to_datetime(row['date_of_birth'])
    gender = row['gender']
    citizen_status = 'Citizen' if row['nationality'].lower() == 'south african' else 'Resident'

    new_id = find_unused_id(existing_ids, date_of_birth, gender, citizen_status)
    
    verify_id_application.at[index, 'id_number'] = new_id
    existing_ids.add(new_id)

    # Print proposed ID number
    print(f"{new_id}")