from PIL import Image
import numpy as np

RGBs = [np.array([245, 10, 10], dtype=np.float32)[np.newaxis, np.newaxis, :],
        np.array([10, 245, 10], dtype=np.float32)[np.newaxis, np.newaxis, :],
        np.array([10, 10, 245], dtype=np.float32)[np.newaxis, np.newaxis, :],
        np.array([245, 245, 10], dtype=np.float32)[np.newaxis, np.newaxis, :],
        np.array([10, 245, 245], dtype=np.float32)[np.newaxis, np.newaxis, :],
        np.array([245, 10, 245], dtype=np.float32)[np.newaxis, np.newaxis, :],
        np.array([127, 127, 127], dtype=np.float32)[np.newaxis, np.newaxis, :],
        ]

def medraw2mask(fn):
    im = np.array(Image.open(fn))[..., :3].astype(np.float32)
    stacks = [np.ones((im.shape[0], im.shape[1], 1), dtype=np.float32) * 125]
    for rgb in RGBs:
        stacks.append(np.power(np.sum(np.power(im - rgb, 2), axis=-1, keepdims=True), 0.5))
    stacks = np.concatenate(stacks, axis=2)
    label = np.argmin(stacks, axis=2).astype(np.int32)
    label[label == 7] = -1
    return label

