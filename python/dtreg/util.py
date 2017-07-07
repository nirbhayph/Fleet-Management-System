#!/usr/bin/python
import sys

# Convert zone_id to coordinates using a pre-determined formula.
def zoneIdToLat(zone_id):
    return (int(zone_id) / 200 + 40 * 100) / 100.0

def zoneIdToLong(zone_id):
    return (int(zone_id) % 200 - 75 * 100) / 100.0


if __name__ == '__main__':
    '''
    Usage: python util.py <zone_id>
    Paste results here to view the box region in Google Maps:
    http://www.darrinward.com/lat-long
    '''
    zone_id = int(sys.argv[1])
    lat = zoneIdToLat(zone_id)
    long = zoneIdToLong(zone_id)
    print 'Zone ID: %d' % int(zone_id)
    print '%.2f,%.2f' % (lat + 0.00, long + 0.00)
    print '%.2f,%.2f' % (lat + 0.01, long + 0.00)
    print '%.2f,%.2f' % (lat + 0.00, long + 0.01)
    print '%.2f,%.2f' % (lat + 0.01, long + 0.01)
