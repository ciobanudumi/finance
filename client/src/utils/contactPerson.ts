import { ContactPerson } from '../types/ContactPerson';

export const getContactPerson = variables => {
  return {
    name: variables.name,
    emailAddress: variables.emailAddress,
    phoneNumber: variables.phoneNumber,
    mobileNumber: variables.mobileNumber,
    zipcode: variables.zipcode,
    houseNumber: variables.houseNumber,
    houseNumberExtension: variables.houseNumberExtension,
    roomNumber: variables.roomNumber,
    street: variables.street,
    city: variables.city,
    notes: variables.notes,
  } as ContactPerson;
};
