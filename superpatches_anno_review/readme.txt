1. Put patches in labeling_user1/patches_<cancertype>/. Filenames must be 1.png, 2.png, 3.png, ...
For example, if the cancer type is brca, then you can put patches in labeling_user1/patches_brca. 
(The script labeling_user1/copy_patches_numbered.sh can help with this task)

2. For each img generate a json file and put it in labeling_user1/label_files_<cancertype>/.
For example, if the cancer type is brca, then you can put patches in labeling_user1/patches_label_files_brca. 
The json filenames has the format im_id_1_*.json, im_id_2_*.json, im_id_3_*.json, ...
This is a sample json file:
{"cancer_type":"brca","label":"low","label_new":"med","original_filename":"TCGA-A1-A0SM-01Z-00-DX1.AD503DBD-4D93-4476-B467-F091254FDF78_23796_69802_33_18.png","prediction_name":"med","prediction_val":35,"user_indx":0,"user_name":"user1"}

3. Repeat steps 1 and 2 for each user, replacing labeling_user1 with labeling_user2, labeling_user3, ...

4. Edit file home.php:
a. the list of cancer types in the
$ctype_list=array("acc","brca","esca","hnsc","kirc","lihc","meso","ov","paad","prad","sarc","tgct","thym");
b. There is a for-loop block for each labeling_user<x> folder. Make sure there is a block for each folder.

5. To convert the json labels to csv use the file generate_anno_csv_from_json.py






