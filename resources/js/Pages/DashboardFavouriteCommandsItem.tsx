import React from "react";
import {PageProps} from "@inertiajs/core";
import {IDeviceFavoriteCommand} from "@/types/inertia";
import Box from "@mui/material/Box";
import {Link} from "@inertiajs/react";

interface IDashboardFavouriteCommandsItemProps extends PageProps {
    device: IDeviceFavoriteCommand;
}

export default ({device}: IDashboardFavouriteCommandsItemProps) => {


    return (
        <Box>
            <div>
                {device.path.map((device) => (
                    <Link
                        style={{fontSize: '0.8rem', color: "inherit", marginLeft: 2, marginRight: 2}}
                        href={"/"}
                        key={device.deviceId}
                    >
                        {device.name}
                    </Link>
                ))}
            </div>

        </Box>
    )
}
