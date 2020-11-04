import numpy as np
import os
import sys
import glob
import pickle;
from shutil import copyfile
import json;

anno_parent_dir = '/home/shahira/TIL_classification/superpatches_anno' 
prediction_dir = '/home/shahira/TIL_classification/superpatches_anno/superpatches_eval' 
model_prefix='tcga_incv4_b128_CEloss_lr5e-5_crop100_noBN_d75_val-strat_semiauto_filtered_by_testset_plus_new3_cont2_e0'
threshold = 0.4
cancer_names = ['acc','brca','esca','hnsc','kirc','lihc','meso','ov','paad','prad','sarc','tgct','thym']
dataset_name = "superpatches_new"

user_folders = glob.glob(os.path.join(anno_parent_dir,'*'))
user_folders= [folder for folder in user_folders \
                if(os.path.isdir(folder))]

missing_labels_log = open(os.path.join(anno_parent_dir, 'missing_labels.txt'), 'w+')


result_files_prefix = os.path.join(prediction_dir, model_prefix );
lbl = np.load(result_files_prefix + '_individual_labels.npy');
filenames = pickle.load(open(result_files_prefix + '_filename.pkl', 'rb'));
#pred = np.load(result_files_prefix + '_pred_new.npy');
if(os.path.isfile(result_files_prefix + '_pred_new.npy')):
    pred = np.load(result_files_prefix + '_pred_new.npy');
elif(os.path.isfile(result_files_prefix + '_pred_prob.npy')):
    pred = np.load(result_files_prefix + '_pred_prob.npy');    
pred= pred.squeeze();
print('pred.shape = ', pred.shape)
#pred = pred[:,:,1] ;
if(len(pred.shape) > 2 and pred.shape[2]>1):
    pred = pred[:,:,1];
elif(len(pred.shape) > 2 and pred.shape[2]==1):
    pred = pred[:,:,0];
elif(len(pred.shape) == 2):
    pred = pred;
pred_b = pred > threshold ;

# get the number of subpatches predicted positive in each superpatch
pred_n = pred_b.sum(axis = 1)

#filenames = np.array(filenames)
#print(filenames)

d = dict() # (tumer type, patch name, user 1, user 2, user 3)
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
        img_lst_filename = os.path.join(folder, 'patches_'+cancer_name, 'image_names.txt')
        file_imgs = open(img_lst_filename, 'r');
        for line in file_imgs:
            line = line.strip()
            if(line == ''):
                continue
            img_id, img_path = line.split(' ')
            img_name = img_path.split('/')[-1]      
            img_name = img_name.strip()
            print(img_id,img_name)
            #print((filenames==img_name).sum())
            #patch_indx_prediction = np.where(filenames==img_name)[0][0]
            try:
                patch_indx_prediction = filenames.index(img_name)
            except:
                continue
            prediction_val = pred_n[patch_indx_prediction]
            lbl_val = lbl[patch_indx_prediction][user_indx]
            print('lbl_val',lbl_val)
            #label_filename = os.path.join(folder, 'label_files_'+cancer_name, 'im_id_'+img_id[:-len('.png')]+'.txt') 
            ##try:
            ##    file_lbl = open(label_filename, 'r');
            ##except:
            ##    missing_labels_log.write(label_filename + '\n')
            #lbl_val = file_lbl.readline().strip()
            #if(lbl_val == 'c1' or lbl_val == 1):
            #    lbl_name = 'low'
            #elif(lbl_val == 'c2' or lbl_val == 2):
            #    lbl_name = 'med'
            #elif(lbl_val == 'c3' or lbl_val == 3):
            #    lbl_name = 'high'
            #elif(lbl_val == 'c4' or lbl_val == 4):
            #    lbl_name = 'ignore'
            if(lbl_val == 1):
                lbl_name = 'low'
            elif(lbl_val == 2):
                lbl_name = 'med'
            elif(lbl_val == 3):
                lbl_name = 'high'
            elif(lbl_val == 4):
                lbl_name = 'ignore'
            if(prediction_val < 21):
                prediction_name = 'low'
            elif(prediction_val > 43):
                prediction_name = 'high'
            else:
                prediction_name = 'med'
            json_filename = os.path.join(folder, 'label_files_'+cancer_name, 'im_id_' +img_id[:-len('.png')]+'_lbl_'+str(lbl_name) + '_pred_'+str(prediction_val)+'.json') 
            print(json_filename)

            dest_file = open(json_filename, 'w+');
            #line = None
            line_json = {'cancer_type':cancer_name
                ,'label':lbl_name
                ,'label_new':lbl_name
                ,'original_filename':img_name
                ,'prediction_name':prediction_name
                ,'prediction_val':int(prediction_val)
                ,'user_indx':user_indx
                ,'user_name':user_name
            }    
            line_new = json.dumps(line_json);
            #line = dest_file.read()
            #if(not line == ''):
            #    line_json = json.loads(line);
            #    line_json['cancer_type']=cancer_name
            #    line_json['label']=lbl_name
            #    line_json['label_new']=lbl_name
            #    line_json['original_filename']=img_name
            #    line_json['prediction_name']=prediction_name
            #    line_json['prediction_val']=prediction_val
            #    line_json['user_indx']=user_indx
            #    line_json['user_name']=user_name
            #    line_new = json.dumps(line_json);
            #else:

            #if(not line):
            #    line_json = json.loads('');
            #    line_json['cancer_type']=cancer_name
            #    line_json['label']=lbl_name
            #    line_json['label_new']=lbl_name
            #    line_json['original_filename']=img_name
            #    line_json['prediction_name']=prediction_name
            #    line_json['prediction_val']=prediction_val
            #    line_json['user_indx']=user_indx
            #    line_json['user_name']=user_name
            #    line_new = json.dumps(line_json);
            dest_file.write(line_new);
            dest_file.close();
        