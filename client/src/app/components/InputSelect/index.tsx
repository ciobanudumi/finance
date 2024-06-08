import * as React from 'react';

import { CFormSelect, CFormLabel, CFormFeedback } from '@coreui/react';

export function InputSelect(props: {
  id: string;
  name: string;
  label: string;
  options: Array<{ value: string | number | undefined; label: string | number | undefined }>;
  register: Function;
  errors: object;
  validationMessage?: string;
  defaultValue?: string | number;
  disabled?: boolean;
  isRequired?: boolean;
}) {
  return (
    <div className="mt-2">
      <CFormLabel htmlFor={props.id} className={props.isRequired ? 'required' : undefined}>
        {props.label}
      </CFormLabel>
      <CFormSelect
        readOnly={props.disabled}
        id={props.id}
        {...props.register(props.name)}
        defaultValue={props.defaultValue}
      >
        {props.options.map(option => (
          <option key={props.label + option.value} value={option.value ?? ''}>
            {option.label ?? ''}
          </option>
        ))}
      </CFormSelect>
      {props.validationMessage && <CFormFeedback invalid>{props.validationMessage}</CFormFeedback>}
    </div>
  );
}

export default InputSelect;
