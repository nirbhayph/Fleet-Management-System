from sklearn.externals import joblib
import sys
zone_id = int(sys.argv[1])
day = int(sys.argv[2])
hour = int(sys.argv[3])
clf = joblib.load('pickups.pkl') 
x = clf.predict([[zone_id,day,hour]])
print x[0]


