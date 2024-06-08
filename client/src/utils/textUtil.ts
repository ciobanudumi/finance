import { ContactPerson } from '../types/ContactPerson';

export function formatAddressContactPerson(contactPerson: ContactPerson): string {
  let fullAddress = contactPerson.zipcode + ', ' + contactPerson.houseNumber;
  fullAddress += contactPerson.houseNumberExtension ? contactPerson.houseNumberExtension : '';
  fullAddress += contactPerson.street ? ', ' + contactPerson.street : '';
  fullAddress += contactPerson.city ? ', ' + contactPerson.city : '';

  return fullAddress;
}
