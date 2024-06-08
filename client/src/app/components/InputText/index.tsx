import * as React from 'react';
import { CFormInput, CFormLabel, CFormFeedback } from '@coreui/react';
// @ts-ignore
import { get, has } from 'lodash';
import { ValidationsType } from '../../../types/Validations';

export function InputText(props: {
  id: string;
  name: string;
  label: string;
  register: Function;
  errors: object;
  validationMessage?: string | ValidationsType;
  defaultValue?: string;
  disabled?: boolean;
  isRequired?: boolean;
  type?: string;
}) {
  const fieldError = has(props.errors, props.name);

  return (
    <div className="mt-2">
      <CFormLabel htmlFor={props.id} className={props.isRequired ? 'required' : undefined}>
        {props.label}
      </CFormLabel>
      <CFormInput
        type={!props.type ? 'text' : props.type}
        readOnly={props.disabled}
        name={props.name}
        id={props.id}
        {...props.register(props.name)}
        invalid={fieldError}
        defaultValue={props.defaultValue}
      />
      {props.validationMessage && typeof props.validationMessage !== 'string' && (
        <CFormFeedback invalid>
          {props.errors[props.name]
            ? props.validationMessage[props.errors[props.name]['type']]
            : get(props.errors, props.name)
            ? props.validationMessage[get(props.errors, props.name)['type']]
            : null}
        </CFormFeedback>
      )}
      {props.validationMessage && typeof props.validationMessage === 'string' && (
        <CFormFeedback invalid>{props.validationMessage}</CFormFeedback>
      )}
    </div>
  );
}

export default InputText;
