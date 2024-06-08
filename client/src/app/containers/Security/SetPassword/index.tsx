import React, { memo, useEffect } from 'react';
import { Helmet } from 'react-helmet-async';
import { useTranslation } from 'react-i18next';
import { useDispatch, useSelector } from 'react-redux';
import classNames from 'classnames';
import { CButton, CCard, CCardBody, CCol, CContainer, CForm, CInputGroup, CInputGroupText, CRow } from '@coreui/react';
import CIcon from '@coreui/icons-react';
import { Link, useSearchParams } from 'react-router-dom';
import { useForm, Controller } from 'react-hook-form';
import { setPasswordActions, reducer, sliceKey } from './slice';
import { useInjectReducer, useInjectSaga } from 'redux-injectors';
import { setPasswordSaga } from './saga';
import { selectIsFormSubmitting, selectError, selectErrorMessage } from './selectors';
import { cilLockLocked } from '@coreui/icons';
import { CFormInput } from '@coreui/react-pro';
import { yupResolver } from '@hookform/resolvers/yup';
import { validationSchema } from './form/validationSchema';
import { appActions } from '../../App/slice';

export const SetPassword = memo(() => {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: setPasswordSaga });

  let [searchParams] = useSearchParams();
  const isFormSubmitting = useSelector(selectIsFormSubmitting);
  const classes = classNames('min-vh-100 d-flex c-default-layout flex-row align-items-center bg-light');
  const { t } = useTranslation();
  const dispatch = useDispatch();

  const { control, handleSubmit } = useForm({
    resolver: yupResolver(validationSchema),
  });

  useEffect(() => {
    return () => {
      dispatch(setPasswordActions.removeData());
    };
  }, [dispatch]);

  const onSubmit = (values: any, event) => {
    let errorMessage = '';
    switch (true) {
      case values.password !== values.repeatPassword:
        errorMessage = 'Repeat fail';
        break;
      case values.password.length < 12:
        errorMessage = 'Length fail';
        break;
      case !/\d/.test(values.password):
        errorMessage = 'Include number fail';
        break;
      case !/[a-z]/.test(values.password):
        errorMessage = 'Lower case fail';
        break;
      case !/[A-Z]/.test(values.password):
        errorMessage = 'Upper case fail';
        break;
      case !/[^a-zA-Z0-9]/.test(values.password):
        errorMessage = 'Special character fail';
        break;
      default:
        break;
    }
    if (errorMessage) {
      dispatch(setPasswordActions.setErrorMessage(errorMessage));
      dispatch(setPasswordActions.setError(true));
      return;
    }

    dispatch(setPasswordActions.setErrorMessage('Error'));
    dispatch(setPasswordActions.setError(null));

    if (!searchParams.get('token')) {
      dispatch(setPasswordActions.setErrorMessage('Token not found'));
      dispatch(setPasswordActions.setError(true));
      return;
    }

    const variables = {
      password: values['password'],
      token: searchParams.get('token'),
    };

    event.target.reset();
    dispatch(setPasswordActions.setPasswordAction(variables));
  };

  const passwordError = useSelector(selectError);
  const passwordErrorMessage = useSelector(selectErrorMessage);
  return (
    <>
      <Helmet>
        <title>Set Password</title>
      </Helmet>
      <div className={classes}>
        <CContainer>
          <CRow className="justify-content-center">
            <CCol md="6">
              <CCard className="p-4">
                <CCardBody>
                  <CForm onSubmit={handleSubmit(onSubmit)}>
                    <h1>Set password</h1>
                    <p className="text-muted">Enter your passowrd</p>
                    <CInputGroup className="mb-3">
                      <CInputGroupText>
                        <CIcon icon={cilLockLocked} />
                      </CInputGroupText>
                      <Controller
                        name="password"
                        control={control}
                        render={({ field }) => (
                          <CFormInput
                            {...field}
                            type="password"
                            placeholder="Password"
                            autoComplete="password"
                            name="password"
                            invalid={passwordError === true}
                          />
                        )}
                      />
                    </CInputGroup>
                    <CInputGroup className="mb-3">
                      <CInputGroupText>
                        <CIcon icon={cilLockLocked} />
                      </CInputGroupText>
                      <Controller
                        name="repeatPassword"
                        control={control}
                        render={({ field }) => (
                          <CFormInput
                            {...field}
                            type="password"
                            placeholder="Reapet password"
                            autoComplete="repeatPassword"
                            name="repeatPassword"
                            invalid={passwordError === true}
                          />
                        )}
                      />
                    </CInputGroup>
                    <div className="text-danger">{passwordError === true && passwordErrorMessage}</div>
                    <p className="text-success">{passwordError === false && 'Success'}</p>
                    <CRow>
                      <CCol xs="6">
                        <CButton type="submit" color="primary" className="px-4" disabled={isFormSubmitting}>
                          Submit
                        </CButton>
                      </CCol>
                      <CCol xs="6" className="d-flex justify-content-end">
                        <Link to="/login" onClick={() => dispatch(appActions.clearUserData())}>
                          <CButton color="link" className="px-0">
                            Back to login
                          </CButton>
                        </Link>
                      </CCol>
                    </CRow>
                  </CForm>
                </CCardBody>
              </CCard>
            </CCol>
          </CRow>
        </CContainer>
      </div>
    </>
  );
});

export default SetPassword;
