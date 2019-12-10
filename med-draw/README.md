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


We also provide a script for processing labels.  
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

Output: output/0_labeled_mask_corrected.png, output/0_labeled_mask_corrected_rgb.png
