#!/bin/bash
#
folders=(paad prad esca acc meso tgct thym ov brca hnsc kirc lihc sarc)
# folders=(paad)
#folders=(prad esca acc meso tgct thym ov brca hnsc kirc lihc sarc)
in_dir=/nfs/data04/shared/shahira/TIL_heatmaps/generate_superpatches/super_patches_0/
out_dir=/nfs/data04/shared/shahira/superpatch_labeling/infiltration_rate_labeling/
end=64
for folder in ${folders[@]}; do
	echo "${folder}"
	for i in $(seq 0 $end); do 
		count=0
		for filepath in $in_dir/${folder}/$i/*.png; do
			count=$((count+1))
		done
		echo "${i} ${count}"
	done
done
