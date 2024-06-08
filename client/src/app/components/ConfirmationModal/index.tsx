import * as React from 'react';
import { CModal, CModalHeader, CModalBody, CModalFooter, CButton, CModalTitle } from '@coreui/react';

export function ConfirmationModal(props: {
  show: boolean;
  onClosed: () => void;
  onConfirmClick: Function;
  headerMessage: string;
  bodyMessage: string;
  buttonLabel: string;
  buttonLabelNo: string;
  isFormSubmitting?: boolean;
  submitButtonColor?: string;
}) {
  return (
    <CModal visible={props.show} backdrop="static" onClose={props.onClosed} size="lg" color="info">
      <CModalHeader closeButton>
        <CModalTitle>{props.headerMessage}</CModalTitle>
      </CModalHeader>
      <CModalBody>{props.bodyMessage}</CModalBody>
      <CModalFooter className={'justify-content-between'}>
        <CButton color="light" onClick={props.onClosed}>
          {props.buttonLabelNo}
        </CButton>
        <CButton
          disabled={props.isFormSubmitting}
          color={props.submitButtonColor}
          onClick={() => props.onConfirmClick()}
        >
          {props.buttonLabel}
        </CButton>
      </CModalFooter>
    </CModal>
  );
}

export default ConfirmationModal;
