import React from "react";
import {Container} from "@mui/material";
import {AppProvider} from "../Providers/AppProvider";

export default function Home(props) {

    console.log(props.data)
    return (
        <AppProvider>
            <Container>
                {props.data.map((site) => site.Description)}
            </Container>
        </AppProvider>
    );
}
