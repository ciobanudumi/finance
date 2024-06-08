import { toInteger } from 'lodash';
import moment from 'moment/moment';

export function getIdFromIri(iri) {
  return toInteger(iri.split('/').slice(-1));
}

export function getIdsFromIriForList(list) {
  const response: Number[] = [];
  list.forEach(value => {
    response.push(getIdFromIri(value));
  });

  return response;
}

export const isWeekDay = date => {
  return date.getDay() % 6 !== 0;
};

export function formatDate(date: Date | null) {
  if (date) {
    const dateWithoutTimezoneOffset = new Date(date.getTime() - date.getTimezoneOffset() * 60000);
    return dateWithoutTimezoneOffset.toISOString().split('T')[0];
  }
  return null;
}

export function getDisplayData(value) {
  return value ? moment(value).format('YYYY-MM-DD') : null;
}
