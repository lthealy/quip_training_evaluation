# Tool for Annotation/Prediction Review and Label Editing # 

Customization steps:

 1. Put patches in labeling\_user1/patches_<cancertype>/. Filenames must be 1.png, 2.png, 3.png, ... <br />
For example, if the cancer type is brca, then you can put patches in labeling\_user1/patches\_brca. <br /> 
(The script labeling\_user1/copy\_patches\_numbered.sh can help with this task)

2. For each patch generate a json file and put it in labeling\_user1/label\_files\_<cancertype>/.<br />
For example, if the cancer type is brca, then you can put patches in labeling\_user1/patches\_label\_files\_brca.<br /> 
The json filenames has the format im\_id\_1\_*.json, im\_id\_2\_*.json, im\_id\_3\_*.json, ...<br />
This is a sample json file:
{"cancer\_type":"brca","label":"low","label\_new":"med","original\_filename":"TCGA-A1-A0SM-01Z-00-DX1.AD503DBD-4D93-4476-B467-F091254FDF78\_23796\_69802_33\_18.png","prediction\_name":"med","prediction\_val":35,"user\_indx":0,"user\_name":"user1"}

3. Repeat steps 1 and 2 for each user, replacing labeling\_user1 with labeling\_user2, labeling\_user3, ...

4. Edit file home.php:
a. the list of cancer types in the
$ctype\_list=array("acc","brca","esca","hnsc","kirc","lihc","meso","ov","paad","prad","sarc","tgct","thym");
b. There is a for-loop block for each labeling\_user<x> folder. Make sure there is a block for each folder.
c. Edit the headings to contain the required text description of the web page.

5. To change the annotation fields:<br/>
    a. To edit the fields with each image, modify the file labeling\_user1/view_patches.php <br/>
	b. to change how the data is saved in json, modify the file labeling\_user1/label.php <br/>    

6. To convert the json files to csv use the file generate\_anno\_csv\_from\_json.py






