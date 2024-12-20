import {IDeviceCommand} from "@/types/inertia";
import Typography from "@mui/material/Typography";
import {PlayArrow} from "@mui/icons-material";
import {Button as BaseButton, Stack, styled} from "@mui/material";
import {grey} from "@mui/material/colors";
import {router} from "@inertiajs/react";
import React from "react";


interface DeviceListItemCommandProps {
    command: IDeviceCommand;
}

const Button = styled(BaseButton)(({theme}) => ({
    backgroundColor: grey[500],
    color: theme.palette.text.primary,
    '&:hover': {
        backgroundColor: grey[800],
        color: theme.palette.common.white,
    },
}));

export default function DeviceListItemCommand({command}: DeviceListItemCommandProps) {

    function handleClick(event: React.MouseEvent) {
        event.preventDefault();
        router.post(route('device.command', { command: command.id}),
            {},
            {
                preserveScroll: true,
                onStart: () => console.log("device started"),
                onSuccess: () => console.log("device successfully started"),
                onError: () => console.log("device start failed"),
            });
    }

    return (
        <Button>
            <Stack
                direction="column"
                spacing={0.5}
                sx={{
                    justifyContent: "flex-start",
                    alignItems: "center",
                    padding: 0.5,
                    width: "5rem",
                }}
                onClick={handleClick}
            >
                <PlayArrow/>
                <Stack
                    direction="row"
                    spacing={0.5}
                    sx={{
                        height: "100%",
                        justifyContent: "center",
                        alignItems: "center",
                    }}
                >
                    <Typography variant={'body2'} sx={{textAlign: "center", lineHeight: 1}}>{command.label}</Typography>
                </Stack>
            </Stack>
        </Button>
    )

}
