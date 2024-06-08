import { configureAppStore } from './configureStore';

export const store = configureAppStore();
export const { dispatch } = store;
