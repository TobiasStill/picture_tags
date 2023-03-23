import {mande} from 'mande'
import type {MandeResponse} from 'mande'
import config from '../../config';
import {ApiOptions} from '@/api/ApiOptions';

export interface Tag {
  name: string,
  author: string,
  notes: [
    {
      author: string,
      note: string,
      date: Date
    }
  ],
  date: Date
}

const _tag = mande(config.API_HOST + '/api/tag', ApiOptions)
const _listing = mande(config.API_HOST + '/api/tag-listing', ApiOptions)

export const fetchListing = () => {
  return _listing.get();
};
export const get = (name: string):MandeResponse<Tag, "json"> => {
  return _tag.get(name);
};
const post = (tag: Tag):MandeResponse<Tag, "json">  => {
  return _tag.post(tag);
};
const put = (tag: Tag):MandeResponse<Tag, "json">  => {
  return _tag.post(tag);
};
const deleteTag = (name: string):MandeResponse<Tag, "json">  => {
  return _tag.delete(name);
};


export const tagApi = {fetchListing, get, put, post, delete: deleteTag};
