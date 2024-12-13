import React from "react";
import {Container} from "@mui/material";
import {AppProvider} from "@/Providers/AppProvider";

export default function Dashboard() {

    return (
        <AppProvider>
            <Container>
                CAME Connect Dashboard
            </Container>
        </AppProvider>
    );
}
