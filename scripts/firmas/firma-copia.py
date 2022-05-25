import shutil
import sys
shutil.copyfile(sys.argv[1],sys.argv[2])
print("OK")
sys.exit(int(sys.argv[3]))
