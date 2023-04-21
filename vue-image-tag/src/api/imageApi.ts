import {mande} from 'mande'
import type {MandeResponse} from 'mande'
import config from '../../config';
import {ApiOptions} from '@/api/ApiOptions';

export interface Image {
    name: string,
    src: string,
    srcSet: string,
    caption?: string,
    description?: string,
    tags: Array<string>
}


const _images = mande(config.API_HOST + '/api/images', ApiOptions)
const _srcSet = mande(config.API_HOST + '/api/image/srcSet', ApiOptions)

const fetchImages = ():MandeResponse<Image[], "json">  => {
    return _images.get();
};
const fetchSrcSet = (name: string):MandeResponse<string[], "json">  => {
    return _srcSet.get(name);
};

export const imageApi = {fetchImages, fetchSrcSet};

