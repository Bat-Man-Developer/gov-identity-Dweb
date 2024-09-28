import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import random
import faker
import rsaidnumber
from sklearn.model_selection import train_test_split,StratifiedKFold, GridSearchCV
from sklearn.preprocessing import LabelEncoder
from sklearn import svm
from sklearn.ensemble import RandomForestClassifier
from sklearn.neighbors import KNeighborsClassifier
from sklearn.metrics import confusion_matrix, accuracy_score, classification_report



fake = faker.Faker()

userData = {
    "id": [],
    "firstName": [],
    "middleName": [],
    "lastName": [],
    "gender": [],
    "citizenship code":[],
    "dob":[]

}

for i in range(700):
    userData['id'].append(i + 1)
    userData['firstName'].append(fake.first_name())
    userData['middleName'].append(fake.first_name())
    userData['lastName'].append(fake.last_name())
    userData['gender'].append(random.choice(['M','F']))
    userData['dob'].append(fake.date_of_birth(minimum_age=18, maximum_age=99))
    userData['citizenship code'].append(random.choice([0,1]))

userDf = pd.DataFrame(userData)

userDf

def generate_sa_id(dob, gender):
    birthdate= dob.strftime("%y%m%d")
    if gender == 'F':
        sequence = str(random.randint(0, 4999)).zfill(4)
    else:
        sequence = str(random.randint(5000, 9999)).zfill(4)

    citizenship_code = random.choice([0,1]) # Look into
    standard_digit = '8'
    partial_id = f"{birthdate}{sequence}{citizenship_code}{standard_digit}"

    #valid_id = f"{birthday}{sequence}{valid_code}{standard_digit}"
    #return 1 if user_id == valid_id else 0

    def luhn_checksum(id_num):
        total = 0
        is_double = False
        for digit in reversed(id_num):
            d = int(digit)
            if is_double:
                d = d * 2
                if d > 9:
                    d -= 9
            total += d
            is_double = not is_double
            return (10 - (total % 10)) % 10
    checksum_digit = luhn_checksum(partial_id)
    id_num = f"{partial_id}{checksum_digit}"
    id_num = id_num[:10] + str(citizenship_code) + id_num[11:]
    return id_num

def validate_user_id(user_id, dob, gender, code):
  sequence = int(user_id[6:10])
  if len(user_id) != 13:
    return 0
  else:
    return 1
  if gender == 'F':
    valid_sequence = 0 < sequence <= 4999
  else:
    valid_sequence = 5000 < sequence <= 9999
    if valid_sequence:
      return 1
    else:
      return 0
  if user_id[12] != str(code):
    return 0
  else:
    return 1
  if user_id[13] != '8':
    return 0
  else:
    return 1
  return 1

userDf['id_number'] = userDf.apply(lambda row: generate_sa_id(row['dob'], row['gender']), axis=1)
userDf['Valid'] = userDf.apply(lambda row: validate_user_id(row['id_number'], row['dob'], row['gender'], row['citizenship code']), axis=1)
#userDf['Valid'] = userDf[['id_number','citizenship code']].apply(validate_user_id())
#userDf['Valid'] = userDf['id_number'].apply(validate_user_id)

userDf

invalidUser = {
    "id": [],
    "firstName": [],
    "middleName": [],
    "lastName": [],
    "gender": [],
    "citizenship code":[],
    "dob":[]

}
for i in range(350):
  invalidUser['id'].append(i + 1)
  invalidUser['firstName'].append(fake.first_name())
  invalidUser['middleName'].append(fake.first_name())
  invalidUser['lastName'].append(fake.last_name())
  invalidUser['gender'].append(random.choice(['M','F']))
  invalidUser['dob'].append(fake.date_of_birth(minimum_age=18, maximum_age=99))
  invalidUser['citizenship code'].append(random.choice([2,3]))

invalidDf = pd.DataFrame(invalidUser)

invalidDf

def generate_invalid_sa_id(dob, gender):
    birthdate = dob.strftime("%y%m%d")

    # Introduce intentional mistakes to create invalid IDs
    sequence = str(random.randint(0, 9999)).zfill(4)  # Allow sequence to go beyond valid ranges
    citizenship_code = random.choice([2, 3])  # Use invalid citizenship codes
    standard_digit = '7'  # Change the standard digit

    partial_id = f"{birthdate}{sequence}{citizenship_code}{standard_digit}"

    def luhn_checksum(id_num):
        total = 0
        is_double = False
        for digit in reversed(id_num):
            d = int(digit)
            if is_double:
                d = d * 2
                if d > 9:
                    d -= 9
            total += d
            is_double = not is_double
        return (10 - (total % 10)) % 10

    checksum_digit = luhn_checksum(partial_id)
    id_num = f"{partial_id}{checksum_digit}"

    return id_num

def validate_invalid_id(id_num):
    if len(id_num) != 13:
        return 0

    sequence = int(id_num[6:10])
    gender = id_num[6]
    if gender == '0':  # Male
        valid_sequence = 0 <= sequence <= 4999
    else:  # Female
        valid_sequence = 5000 <= sequence <= 9999

    valid_citizenship = id_num[10] in ['0', '1']
    valid_standard_digit = id_num[-1] == '8'

    if valid_sequence and valid_citizenship and valid_standard_digit:
        return 1
    else:
        return 0

invalidDf['id_number'] = invalidDf.apply(lambda row: generate_invalid_sa_id(row['dob'], row['gender']), axis=1)
invalidDf['Valid'] = invalidDf['id_number'].apply(validate_invalid_id)

invalidDf

userIDs = pd.concat([userDf, invalidDf], ignore_index=True)

userIDs

userIDs.info()

label_encoder = LabelEncoder()
userIDs['gender'] = label_encoder.fit_transform(userIDs['gender'])

userIDs['dob'] = pd.to_datetime(userIDs['dob'])
userIDs['Age'] = (pd.Timestamp('now') - userIDs['dob']).dt.days//365

# Extracting of dob features
userIDs['birthyear'] = userIDs['dob'].dt.year
userIDs['birthmonth'] = userIDs['dob'].dt.month
userIDs['birthday'] = userIDs['dob'].dt.day

numericData = userIDs.select_dtypes(include=['number'])
correlation_matrix = numericData.corr()

userIDs

"""**Relationship Between Variables**"""

plt.figure(figsize=(10,8))
sns.heatmap(correlation_matrix, annot=True, cmap='coolwarm', fmt='.2f')
plt.title('User Correlation for ID Generation')
plt.show()

#userIDs.to_csv('userIDs.csv', index=False) #prints it into csv file

"""Scatter plot for dob and id

Scatter plot for citizenship code and id

Box and Whiskers Diagram
"""

x = userIDs[['gender', 'citizenship code', 'birthyear', 'birthmonth', 'birthday', 'id_number']]
y = userIDs['Valid']

x

y

# Normalising of data
from sklearn.preprocessing import StandardScaler

scaler = StandardScaler()

x_train, x_test, y_train, y_test = train_test_split(x,y, test_size=0.3, random_state=42)

from sklearn.svm import SVC

x_train = scaler.fit_transform(x_train)
x_test = scaler.fit_transform(x_test)

mrandom = RandomForestClassifier(n_estimators=100, random_state=42)

mrandom.fit(x_train, y_train)

random_pred = mrandom.predict(x_test)
print("Score: ", accuracy_score(y_test, random_pred))

model = SVC(kernel='rbf')
model.fit(x_train, y_train)

y_pred = model.predict(x_test)

#Evaluate Result
print("Confusion Matrix:")
print(confusion_matrix(y_test, y_pred))
print("\nClassification Report:")
print(classification_report(y_test, y_pred))

print("SVM Accuracy:", accuracy_score(y_test, y_pred))



