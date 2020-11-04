# Med-check: tool for manual classification

Requirements:

```javascript
Apache2
PHP >= 5.5
```

To use:

1). Put patches in patches_cancertype/. Filenames must be 1.png, 2.png, 3.png, ...  
For example, if the cancer type is brca, then you can put patches in patches_brca. I have put two example images.

2). Access url: http://..../view_patches.php?ctype=cancertype&page=0  
If cancer type is brca, then access: http://..../view_patches.php?ctype=brca&page=0

3). Human labels will be in label_files_cancertype/
If cancer type is brca human labels are in label_files_brca/

You can have multiple cancertypes. For example, you can create folders label_files_luad, patches_luad. Just make sure to set ctype=luad in the URL.
