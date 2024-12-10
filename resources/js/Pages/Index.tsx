import {AppProvider} from "@/Providers/AppProvider";
import {Container, Grid2 as Grid} from "@mui/material";
import React from "react";
import LoginForm from "@/Components/Auth/LoginForm";

export default function Index() {

    return (
        <AppProvider>
            <Container>
                <Grid container columns={{xs: 1, md: 5}}>
                    <Grid size={1}/>
                    <Grid size={3}>
                        <LoginForm />
                    </Grid>
                    <Grid size={1}/>
                </Grid>
            </Container>
        </AppProvider>
    );
}
