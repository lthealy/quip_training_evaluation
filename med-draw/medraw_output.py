from os import path
import numpy as np
from PIL import Image
from scipy import ndimage
from glob import glob
from medraw_handler import medraw2mask
from skimage.color import label2rgb

for f_idx in [1, 2]:  # process two images
    auto_label = np.array(Image.open('auto_segs/{}_auto_seg.png'.format(f_idx)))
    he_image = np.array(Image.open('auto_segs/{}_original.png'.format(f_idx)))

    fn = 'upload/mask/{}_mask.png'.format(f_idx)
    if path.exists(fn):
        human_label = medraw2mask(fn)
    else:
        human_label = np.zeros((auto_label.shape[0], auto_label.shape[1]), dtype=np.int16)

    human_remove = (human_label == -1)

    human_overwrite = np.zeros_like(human_label)
    for color_idx in range(1, human_label.max() + 1):
        human_overwrite += ndimage.binary_fill_holes(human_label == color_idx)
    human_overwrite = (human_overwrite > 0)

    for nuc_idx in range(1, auto_label.max() + 1):
        nuc_mask = (auto_label == nuc_idx)
        if (nuc_mask * human_remove).sum() > 0:
            auto_label[nuc_mask] = 0
        if (nuc_mask * human_overwrite).sum() > nuc_mask.sum() * 0.40:
            auto_label[nuc_mask] = 0
        if nuc_mask.sum() < 30:
            # Some false auto-segmentation results are very small and hard to spot by eyes.
            auto_label[nuc_mask] = 0


    nuc_add = auto_label.max() + 1
    for color_idx in range(1, human_label.max() + 1):
        color_mask = (human_label == color_idx)
        if color_mask.sum() == 0:
            continue
        nucs, n_nucs = ndimage.measurements.label(color_mask)
        for nuc_idx in range(1, n_nucs + 1):
            nuc_mask = (nucs == nuc_idx)
            nuc_mask = ndimage.binary_fill_holes(nuc_mask)
            auto_label[nuc_mask] = nuc_add
            nuc_add += 1

    Image.fromarray(auto_label).save('output/{}_final_seg.png'.format(f_idx))
    label_rgb = (label2rgb(auto_label, image=he_image, alpha=0.6, bg_label=0) * 255).astype(np.uint8)
    Image.fromarray(label_rgb).save('output/{}_final_seg_visual.png'.format(f_idx))

