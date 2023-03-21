const fetchJson = (key) => {
  return fetch(`./${key}`, {
    method: "GET",
    headers: {
      'Content-Type': 'application/json'
    }
  }).then(response => response.json());
};

const postJson = (key, body) => {
  return fetch(`./${key}`, {
    method: "POST",
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(body)
  }).then(response => response.json());
};

const putJson = (key, body) => {
  return fetch(`./${key}`, {
    method: "PUT",
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(body)
  }).then(response => response.json());
};

const fetchTagListing = () => {
  return fetchJson('api/tag-listing');
};
const fetchTag = (key) => {
  return fetchJson('api/tag/' + key);
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
