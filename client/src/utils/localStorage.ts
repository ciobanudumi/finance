const prefix = 'finance-app:';

export function localStorageGet(key) {
  return localStorage.getItem(`${prefix}${key}`);
}

export function localStorageSet(key, data) {
  return localStorage.setItem(`${prefix}${key}`, data);
}

export function localStorageRemove(key) {
  return localStorage.removeItem(`${prefix}${key}`);
}

export function localStorageClear() {
  return localStorage.clear();
}
