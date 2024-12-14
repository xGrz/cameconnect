import {List, ListItem} from "@mui/material";
import React from "react";
import {IFavoriteCommand} from "@/types/inertia";
import {usePage} from "@inertiajs/react";
import {PageProps} from '@inertiajs/core';

interface DashboardCommandsProps extends PageProps {
    commands: IFavoriteCommand[];
}

export default () => {

    const {commands} = usePage<DashboardCommandsProps>().props;

    return (
        <List>
            {commands.map((command, index) => (
                <ListItem key={index}>{command.deviceName} {command.label}</ListItem>
            ))}
        </List>
    );


}

