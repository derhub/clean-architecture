import './index.scss';

import { Card } from '@material-ui/core';
import { CenterBoxLayout } from 'components/layouts';
import React from 'react';

import { LoginForm } from './login-form';
import { Header } from '../../containers';

export const LoginPage = () => {
  return (
    <>
      <Header position="fixed" />
      <CenterBoxLayout>
        <Card>
          <LoginForm />
        </Card>
      </CenterBoxLayout>
    </>
  );
};
