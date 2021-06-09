import React from 'react'
import {render} from 'react-dom'

import SwaggerUI from "swagger-ui-react"
import "swagger-ui-react/swagger-ui.css"

const App = () => <SwaggerUI url={__SWAGGER_UI_API__} />

render(<App />, document.getElementById('swagger-ui-root'))