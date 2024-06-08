import * as yup from 'yup';

export const validationSchema = yup.object({
  password: yup.string().required(),
  repeatPassword: yup.string().required(),
});
