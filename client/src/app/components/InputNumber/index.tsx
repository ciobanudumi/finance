import * as React from 'react';
import { CFormInput, CFormLabel, CFormFeedback } from '@coreui/react';
// @ts-ignore
import { has } from 'lodash';
import { ValidationsType } from '../../../types/Validations';

export function InputNumber(props: {
  id: string;
  name: string;
  label: string;
  register: Function;
  errors: object;
  validationMessage?: string | ValidationsType;
  disabled?: boolean;
  defaultValue?: number;
  onChangeFunction?: Function;
  isRequired?: boolean;
  placeholder?: string;
  step?: number;
}) {
  const fieldError = has(props.errors, props.name);

  return (
    <div className="mt-2">
      <CFormLabel htmlFor={props.id} className={props.isRequired ? 'required' : undefined}>
        {props.label}
      </CFormLabel>
      <CFormInput
        // @ts-ignore
        onWheel={() => document.activeElement.blur()}
        readOnly={props.disabled}
        type="number"
        step={props.step || 1}
        name={props.name}
        id={props.id}
        {...props.register(props.name, {
          setValueAs: v => (v ? parseInt(v) : null),
        })}
        invalid={fieldError}
        defaultValue={props.defaultValue}
        placeholder={props.placeholder || ''}
        onChange={props.onChangeFunction}
        disabled={props.disabled}
      />
      {props.validationMessage && typeof props.validationMessage !== 'string' && (
        <CFormFeedback invalid>
          {props.errors[props.name] ? props.validationMessage[props.errors[props.name]['type']] : null}
        </CFormFeedback>
      )}
      {props.validationMessage && typeof props.validationMessage === 'string' && (
        <CFormFeedback invalid>{props.validationMessage}</CFormFeedback>
      )}
    </div>
  );
}

export default InputNumber;
