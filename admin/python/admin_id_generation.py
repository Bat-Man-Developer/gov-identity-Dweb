import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import random
import faker
import pickle 
from sklearn.model_selection import train_test_split,StratifiedKFold, GridSearchCV
from sklearn.preprocessing import LabelEncoder
from sklearn import svm
from sklearn.ensemble import RandomForestClassifier
from sklearn.neighbors import KNeighborsClassifier
from sklearn.metrics import confusion_matrix, accuracy_score, classification_report

userIDs = pd.read_csv('userIDs.csv')

x = userIDs[['gender', 'citizenship code', 'birthyear', 'birthmonth', 'birthday', 'id_number']]
y = userIDs['Valid']

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

print(userIDs['Valid'].value_counts())
userIDs['Valid'].value_counts().plot(kind='bar')
plt.xlabel('Valid')

invalid_class = userIDs[userIDs['Valid']==0]
number_invalid = len( invalid_class)
valid_class = userIDs[userIDs['Valid']==1].sample(number_invalid)

final_class = pd.concat([invalid_class, valid_class])
print(final_class['Valid'].value_counts())
final_class['Valid'].value_counts().plot(kind='bar')
plt.xlabel('Valid')

from sklearn.preprocessing import MinMaxScaler
from sklearn.metrics import accuracy_score
from sklearn.model_selection import train_test_split

b_scaler = MinMaxScaler(feature_range=(0,1))

x2 = final_class[['gender', 'citizenship code', 'birthyear', 'birthmonth', 'birthday']]
normalised_x = b_scaler.fit_transform(x2)

y2 = final_class['Valid']

x_train2, x_test2, y_train2, y_test2 = train_test_split(normalised_x, y2, test_size=0.3, random_state=42, stratify = y2)

from sklearn.ensemble import BaggingClassifier
from sklearn.tree import DecisionTreeClassifier
base_classifier = DecisionTreeClassifier(random_state=42)
bagging_classifier = BaggingClassifier(base_classifier, n_estimators=10, random_state=42)
bagging_classifier.fit(x_train2, y_train2)

y_pred2 = bagging_classifier.predict(x_test2)
score = accuracy_score(y_test2, y_pred2)
print("Accuracy:", score)

with open('id_gen_model.pk1', 'wb') as f:
    pickle.dump(model, f)