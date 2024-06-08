import { merge } from 'lodash';
import i18next from 'i18next';
import config from 'config';
// eslint-disable-next-line import/no-cycle

/**
 * Parses the JSON returned by a network request
 *
 * @param  {object} response A response from a network request
 *
 * @return {object}          The parsed JSON from the request
 */
function parseJSON(response) {
  if (response.status === 204 || response.status === 205) {
    return null;
  }
  return response.json();
}

/**
 * Checks if a network request came back fine, and throws an error if not
 *
 * @param  {object} response   A response from a network request
 *
 * @return {object|undefined} Returns either the response, or throws an error
 */
function checkStatus(response) {
  if (response.status >= 200 && response.status < 300) {
    return response;
  }

  if (response.status === 401) {
    // window.location.href = '/login';
  }

  throw new Error(response.statusText);
}

/**
 * Requests a URL, returning a promise
 *
 * @param  {string} url       The URL we want to request
 * @param  {object} [options] The options we want to pass to "fetch"
 *
 * @return {object}           The response data
 */
export function nonJsonRequest(url, options) {
  const finalUrl = config.REACT_APP_API_BASE_URL + url;
  const baseOptions = {
    headers: {
      'Content-Type': 'application/json',
    },
  };
  const finalOptions = merge(baseOptions, options);

  return fetch(finalUrl, finalOptions).then(checkStatus);
}

/**
 * Requests a URL, returning a promise
 *
 * @param  {string} url       The URL we want to request
 * @param  {object} [options] The options we want to pass to "fetch"
 *
 * @return {object}           The response data
 */
export default function request(url, options) {
  const finalUrl = config.REACT_APP_API_BASE_URL + url;
  const baseOptions = {
    headers: {
      'Content-Type': 'application/json',
      'Accept-Language': i18next.language,
      ...options?.headers,
    },
  };
  delete options.headers;

  const finalOptions = merge(baseOptions, options);

  return fetch(finalUrl, finalOptions).then(checkStatus).then(parseJSON);
}
