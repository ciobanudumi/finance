import React from 'react';
import { CFormSwitch, CInputGroup } from '@coreui/react';

export function InputBoolean(props: {
  id: string;
  name: string;
  label: any;
  register: Function;
  onChange?: Function;
  defaultValue?: boolean;
}) {
  return (
    <CInputGroup className="mb-3">
      <CFormSwitch
        {...props.register(props.name)}
        name={props.name}
        id={props.id}
        {...props.register(props.name)}
        defaultChecked={props.defaultValue}
        color="success"
        label={props.label}
        onChange={props.onChange}
      />
    </CInputGroup>
  );
}

export default InputBoolean;
