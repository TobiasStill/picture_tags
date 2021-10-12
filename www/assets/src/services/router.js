let _defaultHash = '';

const getHashFromKey = (key) => {
    return key?`#${key}`:'';
};

const getRouteFromHash = (hash) => (hash && hash.replace(`#/`, '')) || '';

let currentRoute = getRouteFromHash(window.location.hash);

const subscriptions = [];

const publish = () => {
    subscriptions.forEach(subscription => subscription());
};

window.addEventListener('popstate', () => {
    currentRoute = getRouteFromHash(window.location.hash);
    publish();
});

const subscribe = (callback) => {
    subscriptions.push(callback);
    callback();
};

const route = (key) => {
    const hash = getHashFromKey(key) || _defaultHash;
    if(hash === window.location.hash) {
        publish();
        return;
    }
    window.location.hash = hash;
};

const getCurrentImage = () => {
    return currentRoute;
};

const setDefault = (key) => {
    _defaultHash = getHashFromKey(key);
    if(!window.location.hash) {
        window.location.hash = _defaultHash;
    }
};

export const router = {subscribe, route, getCurrentImage, setDefault};
