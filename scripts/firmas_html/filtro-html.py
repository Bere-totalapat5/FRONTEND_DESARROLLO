import shutil
import sys
if sys.argv[3] == "0":
 shutil.copyfile(sys.argv[1],sys.argv[2])
sys.exit(int(sys.argv[3]))
