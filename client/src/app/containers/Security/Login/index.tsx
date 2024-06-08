import { useNavigate } from 'react-router-dom';
import {
  CButton,
  CCard,
  CCardBody,
  CCardGroup,
  CCol,
  CContainer,
  CForm,
  CFormInput,
  CInputGroup,
  CInputGroupText,
  CRow,
  CAlert,
} from '@coreui/react';
import CIcon from '@coreui/icons-react';

import React, { memo, useEffect } from 'react';
import { Helmet } from 'react-helmet-async';
import { useSelector, useDispatch } from 'react-redux';

import { useInjectReducer, useInjectSaga } from 'utils/redux-injectors';
import { reducer, sliceKey, loginActions } from './slice';
import { selectLoginError, selectRefreshError } from './selectors';
import { loginSaga } from './saga';
import { useForm, Controller } from 'react-hook-form';
import { selectIsFormSubmitting, selectUser } from '../../App/selectors';
import classNames from 'classnames';

import { cilLockLocked, cilUser } from '@coreui/icons';
import { useTranslation } from 'react-i18next';
import { InputFields } from './types';

export const Login = memo(() => {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: loginSaga });
  const isFormSubmitting = useSelector(selectIsFormSubmitting);
  const refreshError = useSelector(selectRefreshError);

  const navigate = useNavigate();
  const classes = classNames('min-vh-100 d-flex c-default-layout flex-row align-items-center bg-light');
  const dispatch = useDispatch();
  const user = useSelector(selectUser);
  const { t } = useTranslation();

  useEffect(() => {
    if (user) {
      navigate('/');
    }
    // eslint-disable-next-line
  }, [user]);

  const {
    handleSubmit,
    control,
    formState: { errors },
  } = useForm<InputFields>();

  const onSubmit = vals => {
    dispatch(loginActions.clearError());
    const values = {
      url: '/token',
      payload: vals,
    };
    dispatch(loginActions.loginAction(values));
  };

  return (
    <>
      <Helmet>
        <title>Login</title>
        <meta name="description" content="Description of Login" />
      </Helmet>
      <div className={classes}>
        <CContainer className="mt-5">
          <CRow className="justify-content-center">
            <CCol md="8">
              <CAlert color="danger" visible={refreshError} dismissible={true}>
                <h3>Refresh token fail</h3>
                Refresh token fail
              </CAlert>
              <CCardGroup>
                <CCard className="p-4">
                  <CCardBody>
                    <CForm onSubmit={handleSubmit(onSubmit)}>
                      <h1>Login</h1>
                      <p className="text-medium-emphasis">SignIn</p>
                      <CInputGroup className="mb-3">
                        <CInputGroupText>
                          <CIcon icon={cilUser} />
                        </CInputGroupText>
                        <Controller
                          name="username"
                          control={control}
                          render={({ field }) => (
                            <CFormInput
                              {...field}
                              type="text"
                              placeholder="Username"
                              autoComplete="username"
                              name="username"
                              invalid={!!errors.username}
                            />
                          )}
                        />
                      </CInputGroup>
                      <CInputGroup className="mb-4">
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
                              autoComplete="current-password"
                              invalid={!!errors.password}
                            />
                          )}
                        />
                      </CInputGroup>
                      <div className="text-danger">{useSelector(selectLoginError) ? 'Invalid Credentials' : null}</div>
                      <CRow>
                        <CCol xs="6">
                          <CButton type="submit" className="px-4" disabled={isFormSubmitting}>
                            Login
                          </CButton>
                        </CCol>
                      </CRow>
                    </CForm>
                  </CCardBody>
                </CCard>
                <CCard className="py-5 login-logo">
                  <CCardBody className="text-white d-flex align-items-center justify-content-center">
                    <h2>Finance app</h2>
                  </CCardBody>
                </CCard>
              </CCardGroup>
            </CCol>
          </CRow>
        </CContainer>
      </div>
    </>
  );
});
export default Login;
