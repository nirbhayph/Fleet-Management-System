import pandas as pd
import time
from math import sqrt
import datetime
import numpy as np
from sklearn import datasets, tree
import matplotlib.pyplot as plt
import sklearn.metrics as metrics


data_x = pd.read_csv('/home/nirbhay/Documents/BE/src-code/man_pickups.csv', header=0, nrows=120000, parse_dates = True)
data_x.iloc[:,1] = pd.to_datetime(data_x.iloc[:,1])
data_temp = data_x.iloc[:,1].dt.weekday
data_temp2 = data_x.iloc[:,1].dt.hour
data_x = pd.concat([data_x,data_temp], axis=1)
data_x = pd.concat([data_x,data_temp2], axis=1)
di = []
for x,y in zip(data_x.iloc[:,5],data_x.iloc[:,2]):
    di.append(str(y)+"_"+str(x))
df1 = pd.DataFrame(di)
data_x = pd.concat([data_x,df1], axis=1)
data_x.columns = ['id', 'datetime','zone', 'num_picks', 'day', 'hr','feat']
data_x.sort_values(by='datetime')



train = data_x.head(n=110000)

test = data_x.tail(n=10000)

print train
print test

df1 = train[['zone','day','hr']]
df2 = test[['zone','day','hr']]

train_X = np.asarray(df1)
test_X_ = np.asarray(df2)


y = np.asarray(train.iloc[:,3])
test_y = np.asarray(test.iloc[:,3])
print len(y)
print len(test_y)

print np.shape(train_X)
print np.shape(y)
print np.shape(test_X_)


regr = tree.DecisionTreeRegressor(
            max_features=0.9,
            max_depth=100,
            min_samples_leaf=2
        )

regr.fit(train_X, y)

#DUMP 
from sklearn.externals import joblib
joblib.dump(regr, 'pickups.pkl') 


zz = regr.predict(test_X_)
print zz

np.savetxt("foo1.csv", test_y, delimiter=",")
np.savetxt("foo2.csv", zz, delimiter=",")

print len(zz)
print len(test_y)
print len(test_X_)

m = metrics.mean_absolute_error(test_y, zz)

print 'Mean Absolute Error: %f' % m

# Compute and print root mean squared error.
msd = metrics.mean_squared_error(zz,test_y)
rmsd = sqrt(msd)
print 'RMSD: %f' % rmsd

# Compute and print the coefficient of determination, R^2.
m = metrics.r2_score(test_y, zz)
print 'R^2 Score: %f' % m
print




plt.scatter(test_y,zz,c='r')
plt.scatter(test_y,test_y,c='g')
plt.title('Actual Number of pickups vs predicted number of pickups')
plt.xlabel('Actual Number of Pickups')
plt.ylabel('Predicted Number of Pickups')
plt.show()








