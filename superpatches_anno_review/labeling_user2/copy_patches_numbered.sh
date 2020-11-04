#!/bin/bash
#
# folders=(paad prad esca acc meso tgct thym ov brca hnsc kirc lihc sarc)
# folders=(paad)
folders=(acc brca esca hnsc kirc lihc meso ov paad prad sarc tgct thym)
in_dir=/nfs/data04/shared/shahira/generate_superpatches/super_patches_0_groups/user_2/
out_dir=/nfs/data04/shared/shahira/superpatch_labeling/infiltration_rate_labeling_user2/
for folder in ${folders[@]}; do
	echo "${folder}"
	indx=0
	out_folder=$out_dir/patches_${folder}
	if [ ! -d "$out_folder" ]; then
		mkdir $out_folder
	fi
	echo " " > $out_folder/image_names.txt
	# for filepath in $in_dir/${folder}/*/*.png; do
	for filepath in $in_dir/${folder}/*.png; do
		indx=$((indx+1))
		echo "${filepath}"
		fname=$(basename $filepath)
		#echo "${fname}"
		#fbname=${fname%.*}
		#echo "${fbname}"
		fname_dest=$indx.png
		filepath_dest=$out_folder/$fname_dest
		echo "${filepath_dest}"
		echo "${fname_dest} ${filepath}" >> $out_folder/image_names.txt
		cp $filepath $filepath_dest
	done
done
