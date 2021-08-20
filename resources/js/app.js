import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route } from "react-router-dom";
import About from "./About";

const App = () => {
  return (
    <BrowserRouter>
        <Route path="/about" component={About} />
    </BrowserRouter>
  );
};

if (document.getElementById("app")) {
ReactDOM.render(<App />, document.getElementById("app"));
}