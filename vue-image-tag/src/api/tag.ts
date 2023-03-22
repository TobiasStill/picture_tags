import { mande } from 'mande'

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

export interface Picture {
  name: string,
  src: string,
  tags: Array<string>
}


const tags = mande('/api/tag')
const tagListing = mande('/api/tag-listing')

export const fetchTagListing = () => {
  return tagListing.get();
};
export const fetchTag = (name: string) => {
  return tags.get(name);
};
const postTag = (body) => {
  return postJson('api/tag/', body);
};
const putTag = (body) => {
  return putJson('api/tag/', body);
};
const fetchImages = () => {
  return fetchJson('api/images/');
};
const fetchImage = (key) => {
  return fetchJson('api/image/' + key);
};
const findImagesByTags = (tags) => {
  const param = encodeURIComponent(JSON.stringify(tags));
  return fetchJson('api/image/findByTag?tags=' + param);
};


export const api = {fetchTag, fetchTagListing, postTag, putTag, fetchImage, fetchImages, findImagesByTags};
