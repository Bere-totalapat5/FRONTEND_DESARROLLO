import os
def touch(fname, times=None):
    with open(fname, 'a'):
        os.utime(fname, times)

import sys
for f in sys.argv[1:]:
    touch(f)
