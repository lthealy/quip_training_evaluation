import numpy as np
import os
import sys
import glob

anno_parent_dir = '/home/shahira/TIL_classification/superpatches_anno' 
cancer_names = ['acc','brca','esca','hnsc','kirc','lihc','meso','ov','paad','prad','sarc','tgct','thym']

user_folders = glob.glob(os.path.join(anno_parent_dir,'*'))
user_folders= [folder for folder in user_folders \
                if(os.path.isdir(folder))]

missing_labels_log = open(os.path.join(anno_parent_dir, 'missing_labels.txt'), 'w+')

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
        
            label_filename = os.path.join(folder, 'label_files_'+cancer_name, 'im_id_'+img_id[:-len('.png')]+'.txt') 
            try:
                file_lbl = open(label_filename, 'r');
            except:
                missing_labels_log.write(label_filename + '\n')
            lbl_val = file_lbl.readline().strip()
            if(lbl_val == 'c1'):
                lbl_val = '1'
            elif(lbl_val == 'c2'):
                lbl_val = '2'
            elif(lbl_val == 'c3'):
                lbl_val = '3'
            elif(lbl_val == 'c4'):
                lbl_val = '4'
            else:
                continue
            try:
                img_val = d[img_name]
            except:
                img_val = [cancer_name, img_name, ' ', ' ', ' ']
            img_val [user_indx] = lbl_val
            d[img_name] = img_val

missing_labels_log.close()
final = np.array(list(d.values()))
np.savetxt(os.path.join(anno_parent_dir,'anno.csv'), final, delimiter=',', fmt='%s') 
        