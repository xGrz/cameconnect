import React from "react";
import {Container, List, ListItem} from "@mui/material";
import {AppProvider} from "@/Providers/AppProvider";
import {IFavoriteCommand} from "@/types/inertia";

interface DashboardProps {
    commands: IFavoriteCommand[];
}

export default function Dashboard({commands}: DashboardProps) {

    console.log(commands);
    return (
        <AppProvider>
            <Container>
                CAME Connect Dashboard
                <List>
                    {commands.map((command, index) => (
                        <ListItem key={index}>{command.deviceName} {command.label}</ListItem>
                    ))}
                </List>
            </Container>
        </AppProvider>
    );
}
