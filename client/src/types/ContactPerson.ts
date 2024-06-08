export interface ContactPerson {
  id: string | null;
  contactPersonId: number | null;
  name: string;
  emailAddress: string | null;
  phoneNumber: string;
  mobileNumber: string;
  zipcode: string;
  houseNumber: number;
  houseNumberExtension: string | null;
  roomNumber: number | null;
  street: string | null;
  city: string | null;
  notes: string | null;
}
