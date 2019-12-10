# Med-draw: tool for manual segmentation

Requirements for hosting web page:

```javascript
Apache2
PHP >= 5.5
```

To use:

1). Modify the URL line in _list_images.php before making it work:  
```javascript
http://vision.cs.stonybrook.edu/~lehhou/tcga/medraw0/images/
```

2). Put patches in images/

3). Access url: http://.../medraw.php

4). Human labels will be in upload/

## Postprocessing labels.
We also provide an example script for processing labels.  
Requirements for running label processing code (python):

```python
numpy
Pillow (PIL)
scipy
glob
skimage
```

To use:

```python
python medraw_output.py
```

Output: output/1_final_seg.png, output/2_final_seg.png  
For visualizing results:  
  [output/1_final_seg_visual.png](output/1_final_seg_visual.png)
  [output/2_final_seg_visual.png](output/2_final_seg_visual.png)
