import numpy as np
import os
import sys
import glob
import pickle;
from shutil import copyfile
import json;

anno_parent_dir = '/nfs/vision/shahira/superpatches_anno' 
cancer_names = ['acc','brca','esca','hnsc','kirc','lihc','meso','ov','paad','prad','sarc','tgct','thym']

user_folders = glob.glob(os.path.join(anno_parent_dir,'*'))
user_folders= [folder for folder in user_folders \
                if(os.path.isdir(folder))]




for folder in user_folders:
    if('user1' in folder):
        user_indx = 0
        user_name = 'user1'
    elif('user2' in folder):
        user_indx = 1
        user_name = 'user2'
    elif('user3' in folder):
        user_indx = 2
        user_name = 'user3'
    else:
        continue
    print(user_name)
    for cancer_name in cancer_names:
        print(cancer_name)
        json_lst_filenpaths = glob.glob(os.path.join(folder, 'label_files_'+cancer_name, '*.json'))
        for json_filepath in json_lst_filenpaths:
            print(json_filepath)
            json_file = open(json_filepath, 'r');
            rename = False
            for line in json_file:
                line_json = json.loads(line);
                print(line_json)
                if(line_json['label'] == 'low' and line_json['prediction_val'] < 30):
                    rename = True
                    break
                if(line_json['label'] == 'med' and line_json['prediction_val'] < 50 and line_json['prediction_val'] > 15):
                    rename = True
                    break
                if(line_json['label'] == 'high' and line_json['prediction_val'] > 30):
                    rename = True
                    break
                if(line_json['label'] == 'ignore'):
                    rename = True
                    break

            json_file.close();
            if(rename):
                os.rename(json_filepath, json_filepath + 'x')
        