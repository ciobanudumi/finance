const prefix = 'finance-app:';

export function sessionStorageGet(key) {
  return sessionStorage.getItem(`${prefix}${key}`);
}

export function sessionStorageSet(key, data) {
  return sessionStorage.setItem(`${prefix}${key}`, data);
}

export function sessionStorageRemove(key) {
  return sessionStorage.removeItem(`${prefix}${key}`);
}

export function sessionStorageClear() {
  return sessionStorage.clear();
}
