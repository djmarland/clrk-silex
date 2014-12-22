from BBC.AWS.CloudFormation.Common.Component import Component

component = Component('rmp-silex-reference')
component.set_health_check_url('/rmp-silex-reference/status')
component.set_load_balancer_ports({80: 7080})

# TODO Work out how to generate the Spindle keys in the JSON:
# * StaticAssets resource
# * AssetKey and DestinationKey parameters
# For the moment you will need to manually add these keys back into component.json

component.render()
