import {Stack} from "@mui/material";
import {IDeviceTree} from "@/types/inertia";
import Box from "@mui/material/Box";
import DeviceIcon from "@/Components/Connect/DeviceIcon";
import Typography from "@mui/material/Typography";
import DeviceListItemCommand from "@/Components/Connect/DeviceListItemCommand";

interface DeviceListItemProps {
    device: IDeviceTree;
    level?: number;
}


export default function DeviceListItem({device, level = 1}: DeviceListItemProps) {

    return (
        <>
            <Box sx={{paddingY: 1, paddingLeft: level * 1.5}}>
                <Stack
                    direction="row"
                    spacing={2}
                    sx={{
                        justifyContent: "flex-start",
                        alignItems: "center",
                    }}
                >
                    <DeviceIcon iconName={device.icon_name} online={true}/>
                    <Box>
                        <Typography variant="h5" component="h2">{device.name}</Typography>
                        <Typography variant="body2" component="div">{device.description}</Typography>
                    </Box>
                    {device.commands.length > 0 && (
                        <Stack flexGrow={1} alignSelf="stretch">
                            <Stack
                                direction="row"
                                spacing={0.5}
                                sx={{height: '100%', justifyContent: "flex-end", alignItems: "stretch"}}
                            >
                                {device.commands.map((command, idx) =>
                                    <DeviceListItemCommand key={idx} command={command}/>
                                )}
                            </Stack>
                        </Stack>
                    )}
                </Stack>
            </Box>
            {device.devices.length > 0 && (
                <Box>
                    {device.devices.map((device) => (
                        <DeviceListItem device={device} level={level + 1} key={device.id}/>
                    ))}
                </Box>
            )}
        </>
    )
}
