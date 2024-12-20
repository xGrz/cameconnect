import React from "react";
import {Container} from "@mui/material";
import {AppProvider} from "@/Providers/AppProvider";
import DashboardCommands from "@/Pages/DashboardCommands";

export default () => {
    return (
        <AppProvider>
            <Container>
                <div>CAME Connect Dashboard</div>
                <DashboardCommands/>
            </Container>
        </AppProvider>
    )
}

