import numpy as np
import os
import sys
import glob
import shutil;

anno_parent_dir = '/home/shahira/TIL_classification/superpatches_anno' 
cancer_names = ['acc','brca','esca','hnsc','kirc','lihc','meso','ov','paad','prad','sarc','tgct','thym']
out_dir = '/home/shahira/TIL_classification/superpatches_anno/superpatches_all'

user_folders = glob.glob(os.path.join(anno_parent_dir,'*'))
user_folders= [folder for folder in user_folders \
                if(os.path.isdir(folder))]

d = dict() # (tumer type, patch name, user 1, user 2, user 3)
for folder in user_folders:
    if('user1' in folder):
        user_indx = 2
    elif('user2' in folder):
        user_indx = 3
    elif('user3' in folder):
        user_indx = 4
    else:
        continue
    for cancer_name in cancer_names:
        img_lst_filename = os.path.join(folder, 'patches_'+cancer_name, 'image_names.txt')
        file_imgs = open(img_lst_filename, 'r');
        for line in file_imgs:
            line = line.strip()
            if(line == ''):
                continue
            img_id, img_path = line.split(' ')
            img_name = img_path.split('/')[-1]    
            shutil.copyfile(os.path.join(folder, 'patches_'+cancer_name, img_id), os.path.join(out_dir, img_name), follow_symlinks=False);  

        