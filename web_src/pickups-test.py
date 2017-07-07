import sys
sys.path.append('/home/nirbhay/anaconda2/lib/python2.7/site-packages')
from sklearn.externals import joblib
zone_id = int(sys.argv[1])
day = int(sys.argv[2])
hour = int(sys.argv[3])
clf = joblib.load('pickups.pkl') 
x = clf.predict([[zone_id,day,hour]])
print x[0]


