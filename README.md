Taxi Fleet Management

Owing to the increase in demand for lower fares, lower expected time of arrivals ( ETA ) for taxis and availability, the use of cabs aggregators such as Ola, Uber, Meru etc has increased. These firms rely majorly on cheap manpower to deliver lower ETA at a compelling price. But the cut-throat competition for survival is affecting both, the company and taxi drivers. Our system aims to strike the perfect balance between the above-mentioned factors while not damaging any of the three entities involved namely, consumer, taxi driver and the firm. This project will use data mining to find out hotspots ( prime locations from where the probability of acquiring a fare is high ) and to identify the pattern in which the requests arrive, thus enabling us to predict future request from any location at any point of time. This will help in identifying a number of taxis required at any point of time. The taxi drivers will be directed to nearest hotspots thus reducing their expenditure on fuel and not only helping them to obtain fare but also indirectly reducing ETA for customers. A fair model of client distribution is used to ensure no driver is running into a loss. Thus we have devised a model that will not only help the consumer and firm but also is profitable the middlemen.

# pickups.py
Imports aggregated taxi data, gets it ready according to feature sets and applies DT Regressor using Scikit-Learn, creates pkl.

# util.py
Used for mapping zoneid to coordinates.

# pickups.pkl
Trained Model for hotspot prediction.

# pickups-test.py
Uses trained model (.pkl) to make predictions for new data. eg: "python pickups-test.py 14098 1 1"

# ANFIS
Fuzzy Q learning in Tensorflow  , Training an ANFIS.

# Dataset.py
It creates all possible combinations of waiting time , active time , total fare and ride fare and stores it in dataset.csv

# ANFIS.py
It creates the ANFIS network uses renforcement learning algorithm Q Learning and stores the trained network

# Preprocessing.py 
It generates fuzzy membership fucntions and calculates reward values using PID for each combination in the dataset.csv

# run.py
loads a saved model or creates a new one if saved model isn't found it creates one , and generates Q factor values for each input.
