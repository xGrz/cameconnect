import {Box} from "@mui/material";
import React from "react";
import {usePage} from "@inertiajs/react";
import {PageProps} from '@inertiajs/core';
import {IDeviceFavoriteCommand} from "@/types/inertia";
import DashboardFavouriteCommandsItem from "@/Pages/DashboardFavouriteCommandsItem";

interface DashboardCommandsProps extends PageProps {
    commands: IDeviceFavoriteCommand[];
}

export default () => {
    const {commands} = usePage<DashboardCommandsProps>().props;

    return (
        <Box>
            {commands.map((device) => (
                <DashboardFavouriteCommandsItem device={device} key={device.id}/>
            ))}
        </Box>
    );


}

