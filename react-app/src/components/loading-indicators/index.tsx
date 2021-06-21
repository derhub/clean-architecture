import './index.scss';

import { CircularProgress } from '@material-ui/core';
import React from 'react';

import { CenterBoxLayout } from '../layouts';

export const FullPageLoadingIndicator = () => (
  <CenterBoxLayout>
    <CircularProgress color="secondary" disableShrink />
  </CenterBoxLayout>
);
